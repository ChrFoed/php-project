import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})


export class DataService {


  API = 'http://localhost:8000/api';

  constructor(private http: HttpClient) { }

  getProducts() {
    return this.http.get<any>(`${this.API}/products`);
  }

  getProductsByVendor(vendor: String) {
    return this.http.get<any>(`${this.API}/products/${vendor}`);
  }

  getProductById(id: String) {
    return this.http.get<any>(`${this.API}/products/${id}`);
  }

}
