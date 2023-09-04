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
  showClientNotFoundMessage = false;

  constructor(private http: HttpClient) {}

  onSubmit() {
    this.showSuccessMessage = false;
    this.showErrorMessage = false;

    // Send a POST request to the API with the form data
    this.http.post('http://rest.superwallet.loc/api/loadwallet', this.formData).subscribe({
      next: (response) => {
        // Success callback
        console.log('Response:', response);
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
      value: ''
    };
    this.showSuccessMessage = false;
    this.showErrorMessage = false;
    this.showClientNotFoundMessage = false;
  }
}
