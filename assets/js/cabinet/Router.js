function Router (app, params = null) {

    this.app = null;
    this.routes = [];
    this.default = null;
    this.currentRoute = null;
    this.currentEnemyId = null;

    this.setRoutes = function (routes)
    {
        console.assert(typeof routes === 'object');
        routes.forEach(route => {
            this.setRoute(route);
        });
    };

    this.setRoute = function (route)
    {
        console.assert(typeof route === 'object' || route instanceof Route);
        if (typeof route === 'object') {
            route = new Route(this, route)
        }
        this.routes[route.path] = route;
    };

    this.setDefaultRoute = function (route)
    {
        console.assert(typeof route === 'object' || route instanceof Route);
        if (typeof route === 'object') {
            route = new Route(this, route)
        }
        this.default = route;
    };

    // маршрутизация
    this.routing = function () 
    {
        let currentHash = decodeURIComponent(window.location.hash);
        if (! currentHash) {
            this.currentRoute = findRouteByPath(this.default);
            this.currentEnemyId = null;
        } else {
            let parsed = currentHash.split('#');
            parsed.shift();
            this.currentRoute = findRouteByPath(parsed.shift());
            this.currentEnemyId = parsed.shift();
        }
        console.log(this.currentRoute, this.currentEnemyId);
        this.currentRoute.handle(this.currentEnemyId);

    };

    // поиск маршрута по пути
    let findRouteByPath = (function (path = null) {
        let route = this.routes[path];
        if (! route) route = this.default;
        return route;
    }).bind(this);

    // редирект
    this.redirect = function (to) {
        window.location.href = '#' + to;
    };


    // конструктор
    console.assert(app instanceof App);
    this.app = app;
    if (params) {
        console.assert(typeof params === 'object')
        if (params.routes) this.setRoutes(params.routes);
        if (params.default) this.setDefaultRoute(params.default);
    }


    window.onload = (function () {
        // привязка вызова маршрутизации к событию изменения истории браузера
        // и вызов маршрутизации
        window.onpopstate = this.routing.bind(this);
        this.routing();
    }).bind(this);
}
