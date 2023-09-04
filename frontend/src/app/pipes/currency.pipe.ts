import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'currency'
})
export class CurrencyPipe implements PipeTransform {
  transform(value: string): string {
    // Parse the value as a number and format it as a currency
    const numberValue = parseFloat(value);
    if (!isNaN(numberValue)) {
      return '$' + numberValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
    return value;
  }
}