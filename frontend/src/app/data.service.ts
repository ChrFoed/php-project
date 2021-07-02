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

  deleteProduct(id: String) {
    return this.http.delete<any>(`${this.API}/products/${id}`);
  }

  updateProduct(payload: Object) {
    return this.http.post<any>(`${this.API}/products`, payload);
  }

  getProductsByVendor(vendor: String) {
    return this.http.get<any>(`${this.API}/products/vendor/${vendor}`);
  }

  getProductById(id: String) {
    return this.http.get<any>(`${this.API}/products/${id}`);
  }

  getVendors() {
    return this.http.get<any>(`${this.API}/vendors`);
  }

}
