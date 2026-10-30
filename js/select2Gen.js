function select2ini(donde, url, ph){
    console.log('ME ejecuto')
    $(donde).select2({
        language: "es",
        width: "off",
        allowClear: true,
        width: '100%',
        ajax: {
            url: url,
            type: "post",
            data: function (params) {
                var query = {
                    search: params.term || '',
                    page: params.page || 1
                };
                return query;
            }
        },
        placeholder: ph
    });
}

function select2ini(donde, url, ph, moreParams){
    // console.log('ME ejecuto sobreescrito')
    $(donde).select2({
        language: "es",
        width: "off",
        allowClear: true,
        width: '100%',
        ajax: {
            url: url,
            type: "post",
            data: function (params) {
                /// console.log('soy el params', params)
                
                /// Agrega nuevos parámetros para el select2
                var query = {
                    search: params.term || '',
                    page: params.page || 1
                };
                if (moreParams !== undefined) {
                    Object.keys(moreParams).forEach(key => {
                        Object.assign(query, { [key]: moreParams[key] })
                    })
                }

                return query;
            }
        },
        placeholder: ph
    });
}