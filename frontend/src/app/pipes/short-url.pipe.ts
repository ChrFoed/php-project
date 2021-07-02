import { Pipe, PipeTransform } from '@angular/core';

/*
Thanks to: https://medium.com/@thunderroid/angular-short-url-pipe-long-url-to-short-url-https-github-com-roid-9f6f9dac6696
for this great pipe idea
 */

@Pipe({
  name: 'shortUrl'
})
export class ShortUrlPipe implements PipeTransform {

  transform(url: string): any {
    if (url) {
      const len = url.length;
      if (len > 30) // only shorten if greater than 30
        // change value 21 and 9 as per requirement
        return url.substr(0, 21) + '...' + url.substring(len - 9, len);
      return url;
    }
    return url;
  }

}
