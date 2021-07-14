import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelperService {

  urlParts: RegExp = /(?<!\?.+)(?<=\/)[\w-]+(?=[/\r\n?]|$)/g;

  constructor() { }

  evalPrice(target: Number, current: Number) {
    if (current == 99999) return 'not-available';
    if (target < current) return 'over-price';
    if (target > current) return 'under-price';
    return 'even-price';
  }

  evalUrlContent(vendor: string, matches: string[]): Object {
    let result = { name: '', identifier: '' };
    if (vendor == 'amazon') {
      result['name'] = matches[0][0].replace(/-/g, ' ');
      result['identifier'] = matches[2][0];
    }
    return result;
  }
}
