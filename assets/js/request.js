export function request(url, method, data, divName) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'html',
        success: function (result) {
            $(divName).append(result);
        },
        error: function (error) {
            console.log(`Error ${error}`)
        }
    });
}

