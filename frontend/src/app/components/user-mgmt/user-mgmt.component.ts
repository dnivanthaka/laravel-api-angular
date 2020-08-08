import { Component, OnInit } from '@angular/core';
import { DataService } from './../../data.service';
import { AuthService } from './../../shared/auth.service';

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
  
  UserProfile: User;
  users: Object;

  constructor(
    public authService: AuthService,
    private data: DataService
  ) {
    this.authService.profileUser().subscribe((data:any) => {
      this.UserProfile = data;
    });

  }

  ngOnInit() { 
    this.data.getUsers().subscribe(data => {
      this.users = data;
    });

  }

  deleteUser(name: string, id: number) {
    if(confirm("Are you sure to delete "+name+"?")) {
      console.log("Implement delete functionality here"+id);
    }
  }
}
