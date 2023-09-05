import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { DataService } from '../shared/data.service';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-payment-confirm',
  templateUrl: './payment-confirm.component.html',
  styleUrls: ['./payment-confirm.component.scss']
})
export class PaymentConfirmComponent {
  formData = {
    token: '',
    session: '',
  };

  showSuccessMessage = false;
  showErrorMessage = false;

  constructor(private http: HttpClient, private dataService: DataService) {
    this.dataService.data$.subscribe((data) => {
      this.formData.session = data.session;
    });
  }

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    // Send a POST request to the API with the form data
    const headers = new HttpHeaders()
      .set('content-type', 'application/json')
      .set('Access-Control-Allow-Origin', '*');
    var options = { headers: headers };
    this.http.post(`${environment.apiBaseUrl}/confirmorder`, this.formData, options).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
        this.showSuccessMessage = true;
      },
      error: (error) => {
        // Error callback
        this.showErrorMessage = true;
        console.error('Error:', error);
      },
    });

  }

  onDoneClick() {
    // Reset form data and hide the success message
    this.formData = {
      token: '',
      session: '',
    };
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
  }
}
