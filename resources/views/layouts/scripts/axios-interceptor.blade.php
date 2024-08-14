<script>
    axios.interceptors.response.use(function (response) {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
        return response;
    }, function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        switch (true) {
            case error.response.status >= 500:
                toastr.error('Terjadi Kesalahan server, silakan hubungi Admin.')
                break;

            default:
                break;
        }

        return Promise.reject(error);
    });
</script>
