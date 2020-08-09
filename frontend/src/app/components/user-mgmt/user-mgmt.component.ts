import { Component, OnInit } from '@angular/core';
import { DataService } from './../../data.service';
import { AuthService } from './../../shared/auth.service';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup } from "@angular/forms";

// User interface
export class User {
  id: number;
  name: String;
  email: String;
  address: String;
  role: String;
}

@Component({
  selector: 'app-user-mgmt',
  templateUrl: './user-mgmt.component.html',
  styleUrls: ['./user-mgmt.component.scss']
})

export class UserMgmtComponent implements OnInit {
  public resetPasswordForm: FormGroup;
  public router: Router;
  public UserProfile: User;
  public users: Object;
  public resetPasswordActive: boolean;

  constructor(
    public authService: AuthService,
    private data: DataService,
    public fb: FormBuilder,
  ) {
    this.resetPasswordForm = this.fb.group({
      resetUserId: [''],
      password: [''],
      password_confirmation: [''],
      
    })
    this.authService.profileUser().subscribe((data:any) => {
      this.UserProfile = data;
    });

    this.resetPasswordActive = false;

  }

  ngOnInit() { 
    this.data.getUsers().subscribe(data => {
      this.users = data;
    });

  }

  onResetPasswordClick(id){
    this.resetPasswordActive = true;

    this.resetPasswordForm.get('resetUserId').setValue(id);
  }

  deleteUser(name: string, id: number) {
    if(confirm("Are you sure to delete "+name+"?")) {
      this.data.deleteUser(id).subscribe(data => {
        this.data.getUsers().subscribe(data => {
          this.users = data;
        });
      });
    }
  }

  onResetSubmit(){
    let password = this.resetPasswordForm.controls['password'].value;
    let password_confirm = this.resetPasswordForm.controls['password_confirmation'].value;
    let id = this.resetPasswordForm.controls['resetUserId'].value;

    if(password == '' || password_confirm == ''){
      alert('Password and password confirmation are required!');
      return;
    }

    if(password != password_confirm){
      alert('Password and password confirmation does not match!');
      return;
    }

    this.data.resetPassword(id, password).subscribe(data => {
      alert('Password is now updated!');
      this.resetPasswordForm.reset();
      this.resetPasswordActive = false;
    });
  }
}
