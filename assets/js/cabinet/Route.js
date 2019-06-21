function Route(router, params = null)
{
    this.router = null;
    this.path = null;
    this.title = null;
    this.component = null;
    this.data = null;
    this.mounted = null;
    this.redirect = null;

    // обработка маршрута
    this.handle = function ()
    {
        if (this.redirect) this.router.redirect(this.redirect);
        document.title = this.title;
        if (this.component) this.router.app.render(this.component, this.data, this.mounted);
    };

    // конструктор
    console.assert(router instanceof Router);
    this.router = router;
    if (params) {
        console.assert(typeof params === 'object');
        this.path = params.path;
        this.title = params.title;
        this.component = params.component;
        if (typeof params.data === 'function') {
            this.data = params.data.apply(this.router.app);
        }
        this.mounted = params.mounted;
        this.redirect = params.redirect;
    }
}
