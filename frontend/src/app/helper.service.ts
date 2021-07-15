import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelperService {

  urlParts: RegExp = /(?<!\?.+)(?<=\/)[\w-]+(?=[/\r\n?]|$)/g;
  routeOnly: RegExp = /(^[^?]+)/;

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

  cleanUrl(vendor: string, url: string): any {
    let match = url.match(this.routeOnly);
    while (match != null) {
      return match[0];
    }
    return url;
  }
}
