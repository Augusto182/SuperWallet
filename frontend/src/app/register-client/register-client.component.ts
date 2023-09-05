import { Component } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-register-client',
  templateUrl: './register-client.component.html',
  styleUrls: ['./register-client.component.scss']
})
export class RegisterClientComponent {
  formData = {
    name: '',
    phone: '',
    document: '',
    mail: '',
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
    var options = { headers: headers };
    this.http.post(`${environment.apiBaseUrl}/registerclient`, this.formData, options).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
        this.showSuccessMessage = true;
      },
      error: (error) => {
        // Error callback
        this.showErrorMessage = true;
      },
    });

  }

  onDoneClick() {
    // Reset form data and hide the success message
    this.formData = {
      name: '',
      phone: '',
      document: '',
      mail: ''
    };
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
  }
}