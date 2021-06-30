import { Component, OnInit } from '@angular/core';
import { DataService } from './../data.service';

@Component({
  selector: 'app-landingpage',
  templateUrl: './landingpage.component.html',
  styleUrls: ['./landingpage.component.less']
})
export class LandingpageComponent implements OnInit {

  vendors: any[] = [{
    label: "Amazon.de",
    id: "amazon.de"
  },
  {
    label: "Cyperport AT",
    id: "cyperport"
  }, {
    label: "Cyperport AT",
    id: "cyperport"
  }]

  products: any[] = [];

  constructor(private data: DataService) { }

  // Angular 2 Life Cycle event when component has been initialized
  ngOnInit() {
    this.data.getProducts().subscribe((products: any) => {
      console.log(products)
    })
  }

}
