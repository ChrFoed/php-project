import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import { Notifications, NotificationType } from './notifications';
import { ToastrService } from 'ngx-toastr';

@Injectable({
  providedIn: 'root'
})
export class NotificationsService {

  private notificationSubject: Subject<Notifications> = new Subject<Notifications>();

  createMessage(message: Notifications) {
    this.notificationSubject.next(message);
  }

  constructor(private toastrService: ToastrService) {
    this.notificationSubject.subscribe(message => {
      switch (message.type) {
        case NotificationType.success:
          this.toastrService.success(message.message);
          break;
        case NotificationType.error:
          this.toastrService.error(message.message);
          break;
        case NotificationType.warning:
          this.toastrService.warning(message.message);
          break;
        case NotificationType.info:
          this.toastrService.info(message.message);
          break;
        default:
        case NotificationType.info:
          this.toastrService.info(message.message);
          break;
      }
    }, err => {
      console.log(`an error occured: ${err}`);
    });

  }
}
