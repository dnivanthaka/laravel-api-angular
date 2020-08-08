import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from './../../shared/auth.service';
import { FormBuilder, FormGroup } from "@angular/forms";
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.scss']
})

export class SignupComponent implements OnInit {
  registerForm: FormGroup;
  errors = null;

  constructor(
    public router: Router,
    public fb: FormBuilder,
    public authService: AuthService
  ) {
    this.registerForm = this.fb.group({
      name: [''],
      email: [''],
      address: [''],
      password: [''],
      password_confirmation: ['']
    })
  }

  ngOnInit() { }

  onSubmit() {
    
    this.authService.register(this.registerForm.value).subscribe(
      result => {
        console.log(result)
      },
      error => {
        if (error instanceof HttpErrorResponse) {
          if (error.status === 422) {
          const validationErrors = error.error.errors;
          this.errors = validationErrors;
          }else if(error.status === 200){

          }
        }
      },
      () => {
        this.registerForm.reset()
        this.router.navigate(['login']);
      }
    )
  }

}
