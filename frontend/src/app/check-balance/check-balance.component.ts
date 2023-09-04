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

  showSuccessMessage = false;
  showErrorMessage = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    // Send a POST request to the API with the form data
    const headers = new HttpHeaders()
      .set('content-type', 'application/json')
      .set('Access-Control-Allow-Origin', '*');
    const queryParams = new HttpParams()
      .set("phone", this.formData.phone)
      .set("document", this.formData.document);
    var options = { headers: headers, params:queryParams };
    this.http.get('http://rest.superwallet.loc/api/checkbalance', options).subscribe({
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
}
