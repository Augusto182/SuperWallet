import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { environment } from '../../environments/environment';
import { DataService } from '../shared/data.service';

@Component({
  selector: 'app-payment',
  templateUrl: './payment.component.html',
  styleUrls: ['./payment.component.scss']
})
export class PaymentComponent {
  formData = {
    phone: '',
    document: '',
    value: '',
    description: '',
    session: '',
  };

  showSuccessMessage = false;
  showErrorMessage = false;
  showClientNotFoundMessage = false;
  showInsufficientBalanceMessage = false;

  constructor(private http: HttpClient, private router: Router, private dataService: DataService) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
    this.showClientNotFoundMessage = false;
    this.showInsufficientBalanceMessage = false;

    // Send a POST request to the API with the form data
    const headers = new HttpHeaders()
      .set('content-type', 'application/json')
      .set('Access-Control-Allow-Origin', '*');
    var options = { headers: headers };
    this.http.post<{ session: string }>(`${environment.apiBaseUrl}/createorder`, this.formData, options).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
        this.showSuccessMessage = true;
        this.dataService.sendData({ session: response.session});
        this.router.navigate(['payment-confirm']);
      },
      error: (error) => {
        // Error callback
        if (error.error.code == "404" && error.error.message == "Client not found.") {
          this.showClientNotFoundMessage = true;
        }
        else if (error.error.code == "400" && error.error.message == "Insufficient Balance.") {
          this.showInsufficientBalanceMessage = true;
        }
        else {
          this.showErrorMessage = true;
        }
      },
    });

  }

  onDoneClick() {
    // Reset form data and hide the success message
    this.formData = {
      phone: '',
      document: '',
      value: '',
      description: '',
      session: '',
    };
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
    this.showClientNotFoundMessage = false;
    this.showInsufficientBalanceMessage = false;
  }
}
