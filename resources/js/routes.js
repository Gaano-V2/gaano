import Welcome from './components/WelcomeApp';
import Home from './components/HomeApp';
import Register from './components/Auth/Register';
import Profile from './components/Auth/Profile';

//Admin
import Admin_Home from './components/Admin/HomeApp';
import Admin_Profile from './components/Admin/Profile';
import Admin_Vehicle from './components/Admin/Vehicle';
import Admin_Users from './components/Admin/Users';
import Admin_Users_Read from './components/Admin/UserRead';
import Admin_Reservation from './components/Admin/Reservation';
import Admin_Reservation_Read from './components/Admin/Reservation_Read';
import Admin_Repair from './components/Admin/Repair';

export const routes = [

  {
    path: '/',
    component: Welcome,
  },

  {
    path: '/register',
    component: Register,
  },

  {
    path: '/home',
    component: Home,
    meta: {
        requiresAuth: true,
        permisson: 'user'
    }
  },

  {
    path: '/profile/:fname-:lname',
    component: Profile,
    meta: {
        requiresAuth: true,
        permisson: 'user'
    }
  },

  //Admin

  {
    path: '/admin',
    component: Admin_Home,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/profile',
    component: Admin_Profile,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/vehicle',
    component: Admin_Vehicle,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/users',
    component: Admin_Users,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/user/:id',
    component: Admin_Users_Read,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/reservation',
    component: Admin_Reservation,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/reservation/:id',
    component: Admin_Reservation_Read,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },

  {
    path: '/admin/repair',
    component: Admin_Repair,
    meta: {
        requiresAuth: true,
        permisson: 'admin'
    },
  },


];
