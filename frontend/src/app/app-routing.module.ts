import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { FrontPageComponent } from './front-page/front-page.component';
import { CheckBalanceComponent } from './check-balance/check-balance.component';
import { LoadWalletComponent } from './load-wallet/load-wallet.component';
import { PaymentComponent } from './payment/payment.component';
import { PaymentConfirmComponent } from './payment-confirm/payment-confirm.component';
import { RegisterClientComponent } from './register-client/register-client.component';

const routes: Routes = [
  { path: '', component: FrontPageComponent },
  { path: 'check-balance', component: CheckBalanceComponent },
  { path: 'load-wallet', component: LoadWalletComponent },
  { path: 'payment', component: PaymentComponent },
  { path: 'payment-confirm', component: PaymentConfirmComponent },
  { path: 'register-client', component: RegisterClientComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
