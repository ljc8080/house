class HttpRequest{
    send(url, data = {}, method = 'get', dataType = 'json'){
        let p = new Promise((resolve, reject) => {
            $.ajax({
                method,
                url,
                data,
                dataType,
                success: res => resolve(res),
                fail: err => reject(err)
            });
        })
        return p;
    }
}
export default new HttpRequest;