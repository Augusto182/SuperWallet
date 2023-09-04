import { Component } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

@Component({
  selector: 'app-check-balance',
  templateUrl: './check-balance.component.html',
  styleUrls: ['./check-balance.component.scss']
})
export class CheckBalanceComponent {
  formData = {
    phone: '',
    document: '',
  };

  balance: string = ''; 

  showSuccessMessage = false;
  showErrorMessage = false;
  showClientNotFoundMessage = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
    this.showClientNotFoundMessage = false;

    const headers = new HttpHeaders()
      .set('content-type', 'application/json')
      .set('Access-Control-Allow-Origin', '*');
    const queryParams = new HttpParams()
      .set("phone", this.formData.phone)
      .set("document", this.formData.document);
    var options = { headers: headers, params:queryParams };
    this.http.get<{ balance: string }>('http://rest.superwallet.loc/api/checkbalance', options).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
        this.balance = response.balance;
        this.showSuccessMessage = true;
      },
      error: (error) => {
        // Error callback
        if (error.error.code == "404" && error.error.message == "Client not found.") {
          this.showClientNotFoundMessage = true;
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
    };
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
    this.showClientNotFoundMessage = false;
  }

}
