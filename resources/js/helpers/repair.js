export function repair_all() {

    return new Promise((res, rej) => {

        axios.get('/api/repair/all').then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}



export function repair_create(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('vehicleid', credential.id);
        formData.append('image', credential.image);
        formData.append('brand', credential.brand);
        formData.append('name', credential.name);
        formData.append('seats', credential.seat);
        formData.append('d_price', credential.d_price);
        formData.append('w_price', credential.w_price);
        formData.append('m_price', credential.m_price);
        formData.append('gas', credential.gas);
        formData.append('transmission', credential.transmission);

        axios.post('/api/vehicle/update', formData,{
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

export function repair_update(credential) {

    return new Promise((res, rej) => {

        let formData = new FormData();
        formData.append('vehicleid', credential.id);
        formData.append('image', credential.image);
        formData.append('brand', credential.brand);
        formData.append('name', credential.name);
        formData.append('seats', credential.seat);
        formData.append('d_price', credential.d_price);
        formData.append('w_price', credential.w_price);
        formData.append('m_price', credential.m_price);
        formData.append('gas', credential.gas);
        formData.append('transmission', credential.transmission);

        axios.post('/api/vehicle/update', formData,{
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
