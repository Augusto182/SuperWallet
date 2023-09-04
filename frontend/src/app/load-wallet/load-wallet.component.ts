import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-load-wallet',
  templateUrl: './load-wallet.component.html',
  styleUrls: ['./load-wallet.component.scss']
})
export class LoadWalletComponent {
  formData = {
    document: '',
    phone: '',
    value: '',
  };

  showSuccessMessage = false;
  showErrorMessage = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    // Send a POST request to the API with the form data
    this.http.post('http://rest.superwallet.loc/api/loadwallet', this.formData).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
      },
      error: (error) => {
        // Error callback
        console.error('Error:', error);
      },
    });

  }
}
