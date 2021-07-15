import { Component, OnInit, Input } from '@angular/core';
import { DataService } from './../data.service';
import { HelperService } from './../helper.service';
import { NotificationsService } from './../notifications.service';
import { NotificationType } from './../notifications';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.less']
})
export class ProductsComponent implements OnInit {

  @Input() public vendorId: String = 'all';

  products: any = [];

  evalPrice: any;

  constructor(private data: DataService, private helper: HelperService, private notificationsService: NotificationsService) {
    this.evalPrice = this.helper.evalPrice;
  }

  // Angular 2 Life Cycle event when component has been initialized
  ngOnInit() {
    this.data.getLastProductsStateByVendor(this.vendorId).subscribe((products: any) => {
      this.products = products['data'];
    });
  }

  updateProduct(product: any) {
    this.data.updateProduct(product).subscribe((response: Object) => {
      this.notificationsService.createMessage({
        message: 'Product deleted successfully', type: NotificationType.success
      });
    });
  }

  deleteProduct(identifier: String) {
    this.data.deleteProduct(identifier).subscribe((response: Object) => {
      this.notificationsService.createMessage({
        message: 'Product deleted successfully', type: NotificationType.info
      });
    });
  }

  fetchProduct(identifier: String) {
    this.data.scrapProductById(this.vendorId, identifier).subscribe((response: Object) => {
      this.notificationsService.createMessage({
        message: 'Product fetched successfully', type: NotificationType.info
      });
    });

  }
}
