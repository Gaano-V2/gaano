import { setAuthorization } from "./authorization";

export function register(credentials) {

    return new Promise((res, rej) => {

      axios.post('/api/authentication/register', {

        email: credentials.email,

        password: credentials.password,

        password_confirmation: credentials.password_confirmation,

        fname: credentials.fname,

        mname: credentials.mname,

        lname: credentials.lname,

        gender: credentials.gender,

        bday: credentials.bday,

        phone: credentials.phone,

      }).then(response => {

        setAuthorization({token: response.data.access_token});
        res(response.data);

      }).catch(error => {

        rej(error.response.data);

      });

    });

  }

  export function login(credentials) {

      return new Promise((res, rej) => {

          axios.post('/api/authentication/login', {

              email: credentials.email,

              password: credentials.password,

          }).then(response => {

              setAuthorization({token: response.data.access_token});
              res(response.data);

          }).catch(error => {

              rej(error.response.data);

          });

      });

  }

  export function logout(credentials) {

      return new Promise((res, rej) => {

        axios.post('/api/authentication/logout', {

            token: credentials.token

        }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

      });

  }

  export function getLocalUser() {

      const userStr = localStorage.getItem("user");

      if (!userStr) {
          return null;
      }

      return JSON.parse(userStr);

  }
