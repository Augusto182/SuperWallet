import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-register-client',
  templateUrl: './register-client.component.html',
})
export class RegisterClientComponent {
  formData = {
    name: '',
    phone: '',
    id: '',
    email: '',
  };

  showSuccessMessage = false;
  showErrorMessage = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    // Send a POST request to the API with the form data
    this.http.post('http://rest.superwallet.loc/api/registerclient', this.formData).subscribe({
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