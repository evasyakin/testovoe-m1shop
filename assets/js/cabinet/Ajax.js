function Ajax(){
    function getXmlHttp(){
        try {xhr = new XMLHttpRequest();} catch (e){
        try {xhr = new ActiveXObject('Microsoft.XMLHTTP');} catch (e){
        try {xhr = new ActiveXObject('Msxml2.XMLHTTP');} catch (e){ return false;}}}
        return xhr;
    }

    function prepareData(data){
        switch (typeof data) {
            case 'string': case 'number':
                // если пустая строка, возвращаем null
                if (data === '') return null;
                return data;
            case 'boolean':
                // если boolean, возвращаем приведение к number
                return Number(data);
            case 'object': case 'array':
                // фикс ошибки типа null в js, возвращаем null
                if (data === null) return null;
                let str = '';
                let i = 0;
                for(index in data) {
                    if (i > 0) {
                        str += '&';
                    }
                    str += encodeURIComponent(index) + '=' + encodeURIComponent(data[index]);
                    i++;
                }
                return str;
            case 'function':
                // если тип function, возвращаем null
                return null;
        }
    }

    function send(method, url, callback, data = null){
        method = method.toUpperCase();
        let xhr = getXmlHttp();
        if (xhr === false) return false;
        xhr.onreadystatechange = function (){
            if (xhr.readyState == 4) callback(xhr.responseText, xhr.status);
        };
        data = prepareData(data);
        if (data && method == 'GET') url += '?' + data;
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send((method == 'POST') ? data : null);
        // console.log('Отправка данных', method, url, data);
        this.loading();
    }

    this.post = function (url, callback, data = null){
        return send.call(this, 'POST', url, callback, data);
    };

    this.get = function (url, callback, data = null){
        return send.call(this, 'GET', url, callback, data);
    };

    this.loading = function (){
        console.log('loading...');
    };
}
