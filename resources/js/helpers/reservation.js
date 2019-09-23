export function vehicle_check(start, end) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('start', start);
        formData.append('end', end);

        axios.post('/api/reservation/vehicle/check', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_all(page = 1) {

    return new Promise((res, rej) => {

        axios.get('/api/reservation/all?page=' + page).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_search(page, search_val) {

    console.log(page);

    if(search_val.walkin === void(0) || search_val.status === "") {
        search_val.walkin = false;
        console.log(search_val.walkin);
    }
    if(search_val.dates[0] === void(0)) {
        search_val.dates[0] = null;
    }
    if(search_val.dates[1] === void(0)) {
        search_val.dates[1] = null;
    }
    if(search_val.fname === void(0)) {
        search_val.fname = null;
    }
    if(search_val.mname === void(0)) {
        search_val.mname = null;
    }
    if(search_val.lname === void(0)) {
        search_val.lname = null;
    }
    if(search_val.email === void(0)) {
        search_val.email = null;
    }
    if(search_val.vehicle === void(0)) {
        search_val.vehicle = null;
    }
    if(search_val.brand === void(0)) {
        search_val.brand = null;
    }
    if(search_val.status === void(0) || search_val.status === "") {
        search_val.status = null;
    }

    return new Promise((res, rej) => {

        axios.get('/api/reservation/search?page=' + page +
        '&walkin=' + search_val.walkin +
        '&start_date=' + search_val.dates[0] +
        '&end_date=' + search_val.dates[1] +
        '&fname=' + search_val.fname +
        '&mname=' + search_val.mname +
        '&lname=' + search_val.lname +
        '&email=' + search_val.email +
        '&vehicle=' + search_val.vehicle +
        '&brand=' + search_val.brand +
        '&status=' + search_val.status

        ).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_create(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('vehicle_id', credential.vehicleid);
        formData.append('start_date', credential.date[0]);
        formData.append('end_date', credential.date[1]);
        formData.append('time', credential.time);
        formData.append('email', credential.email);
        formData.append('fname', credential.fname);
        formData.append('mname', credential.mname);
        formData.append('lname', credential.lname);
        formData.append('gender', credential.gender);
        formData.append('phone', credential.phone);
        formData.append('bday', credential.bday);
        formData.append('government_id', credential.government_id);
        formData.append('license', credential.license);

        axios.post('/api/reservation/create', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_read(id) {

  return new Promise((res, rej) => {

      axios.get('/api/reservation/read/' + id).then(response => {

          res(response.data);

      }).catch(error => {

          rej(error.response.data);

      });

  });

}

export function reservation_update_status(id, status, total) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('reservationid', id);
        formData.append('status', status);
        formData.append('total', total);

        axios.post('/api/reservation/update/status', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_update_date(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('reservationid', credential.reservationid);
        formData.append('start', credential.start);
        formData.append('end', credential.end);
        formData.append('time', credential.time);

        axios.post('/api/reservation/update/date', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_update_vehicle(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('reservationid', credential.reservationid);
        formData.append('vehicleid', credential.vehicleid);

        axios.post('/api/reservation/update/vehicle', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_near_date(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('reservationid', credential.reservationid);
        formData.append('start', credential.start);
        formData.append('vehicleid', credential.vehicleid);

        axios.post('/api/reservation/near/date', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function reservation_update_walkin(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('walkinid', credential.id);
        formData.append('email', credential.email);
        formData.append('fname', credential.fname);
        formData.append('mname', credential.mname);
        formData.append('lname', credential.lname);
        formData.append('gender', credential.gender);
        formData.append('bday', credential.bday);
        formData.append('phone', credential.phone);

        axios.post('/api/reservation/update/walkin', formData,{
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}
