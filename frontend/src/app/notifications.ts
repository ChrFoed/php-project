export class Notifications {
  message: string = "";
  type: NotificationType = 0;
}

export enum NotificationType {
  success = 0,
  warning = 1,
  error = 2,
  info = 3
}
