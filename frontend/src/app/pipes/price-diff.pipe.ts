import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'priceDiff'
})
export class PriceDiffPipe implements PipeTransform {

  transform(targetprice: any, arg1: any): any {
    if (targetprice && arg1) {
      if (arg1 == 99999) return "";
      if (arg1 <= targetprice) return `Savings: +${(targetprice - arg1)}€`;
      if (arg1 > targetprice) return `Loss: ${(targetprice - arg1)}€`;
    }
    return targetprice;
  }
}
