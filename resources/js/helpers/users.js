export function users_all() {

    return new Promise((res, rej) => {

        axios.get('/api/users/all').then(response => {

            res(response.data);

        }).catch(error => {

            rej(error.response.data);

        });

    });

}

export function users_read(id) {

    return new Promise((res, rej) => {

        axios.get('/api/users/read/' + id, {
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

export function update_status(id, status) {

    return new Promise((res, rej) => {

      let formData = new FormData();
      formData.append('userid', id);
      formData.append('status', status);

      axios.post('/api/users/update', formData,{
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
