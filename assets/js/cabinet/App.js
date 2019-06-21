function App(params)
{
    this.selector = null;
    this.element = null;
    this.router = null;
    this.store = null;
    this.api = null;

    // установка маршрутизатора
    this.setRouter = function (router) 
    {
        let isObject = typeof router === 'object';
        console.assert(isObject || router instanceof Router);
        if (isObject) {
            router = new Router(this, router);
        }
        this.router = router;
    };

    // установка хранилища
    this.setStore = function (store)
    {
        // console.log('setStore');
        // let isObject = typeof store === 'object';
        // console.assert(isObject || store instanceof Store);
        // if (isObject) {
        //     store = new Store(this, store);
        // }
        // this.store = store;
        // console.log(this.store);
        console.assert(typeof store === 'object');
        this.store = store;
    }

    // установка api
    this.setApi = function (api)
    {
        let isObject = typeof api === 'object';
        console.assert(isObject || api instanceof Api);
        if (isObject) {
            api = new Api(this, api);
        }
        this.api = api;
    }

    // рендер
    this.render = function (code, data, mountedCallback)
    {
        console.assert(typeof code === 'string');
        if (data) {
            // code = code.match(/\{\{( ?[a-z]{1}[a-zA-Z0-9_-]*.?)* ?\}\}/g, 'lol');
            console.log(code);
            console.log(data);
            for (index in data) {
                let value = data[index];
                // if (typeof value === 'object') {

                // }
                let reg = new RegExp('\{\{ ?' + index + ' ?\}\}', 'g');
                console.log(reg, value);
                code = code.replace(reg, value);
            }
            console.log(code);
        }
        this.element.innerHTML = code;
        if (typeof mountedCallback === 'function') mountedCallback.apply(this);
    }

    // конструктор
    console.assert(typeof params === 'object');
    this.selector = params.selector;
    this.element = document.querySelector(this.selector);
    console.assert(this.element !== null);
    if (params.api) this.setApi(params.api);
    if (params.store) this.setStore(params.store);
    if (params.router) this.setRouter(params.router);
}
