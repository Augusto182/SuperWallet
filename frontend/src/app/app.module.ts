import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { RegisterClientComponent } from './register-client/register-client.component';
import { FrontPageComponent } from './front-page/front-page.component';
import { LoadWalletComponent } from './load-wallet/load-wallet.component';
import { CheckBalanceComponent } from './check-balance/check-balance.component';
import { PaymentComponent } from './payment/payment.component';
import { PaymentConfirmComponent } from './payment-confirm/payment-confirm.component';

@NgModule({
  declarations: [
    AppComponent,
    RegisterClientComponent,
    FrontPageComponent,
    LoadWalletComponent,
    CheckBalanceComponent,
    PaymentComponent,
    PaymentConfirmComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
