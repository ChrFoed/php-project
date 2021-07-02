import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelperService {

  constructor() { }

  evalPrice(target: Number, current: Number) {
    if (current == 99999) return 'not-available';
    if (target < current) return 'over-price';
    if (target > current) return 'under-price';
    return 'even-price';
  }
}
