function Store(app, params = null)
{
    // конструктор
    console.assert(app instanceof App);
    console.assert(typeof params === 'object' || params === null);

    this.app = app;
    this.params = params;

    this.set = function (name, value)
    {
        let isString = typeof name === 'string';
        console.assert(isString || typeof name === 'object');
        if (isString) {
            this.params[name] = value;
        } else {
            name.forEach((item, index) => {
                this.params[index] = item;
            });
        }
    }

    this.update = function (key, value)
    {
        this.params[key] = value;
    };
}
