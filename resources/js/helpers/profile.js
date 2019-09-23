import { setAuthorization } from "./authorization";

export function avatar_update(avatar, key) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('avatar', avatar);
        formData.append('key', key);

        axios.post('/api/profile/avatar', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            setAuthorization({token: response.data.access_token});
            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function profile_update(credentials, key) {

    return new Promise((res, rej) => {

        axios.post('/api/profile/info', {

            fname: credentials.fname,

            lname: credentials.lname,

            gender: credentials.gender,

            bday: credentials.bday,

            phone: credentials.phone,

            key: key

        }).then(response => {

            setAuthorization({token: response.data.access_token});
            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function email_update(email, key) {

    return new Promise((res, rej) => {

        axios.post('/api/profile/email', {

            email: email,

            key: key

        }).then(response => {

            setAuthorization({token: response.data.access_token});
            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function password_update(credentials, key) {

    return new Promise((res, rej) => {

        axios.post('/api/profile/password', {

            current_password: credentials.current_password,

            password: credentials.password,

            password_confirmation: credentials.password_confirmation,

            key: key

        }).then(response => {

            setAuthorization({token: response.data.access_token});
            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function credential_update(credential, key) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('government_id', credential.government_id);
        formData.append('license', credential.license);
        formData.append('key', key);

        axios.post('/api/profile/credential', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            setAuthorization({token: response.data.access_token});
            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}
