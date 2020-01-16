ymaps.ready(function(){
    let map = new obMap({
            mapId: "map",
            mapCenter: [59.92433655, 30.48690006],
            mapZoom: 17
        }),
        MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="width:270px;height:136px;margin-left:-185px;margin-top:-136px;text-align:center" class="card-body bg-white"><img src="/local/templates/common/images/logo.png" style="max-height: 100%"></div>',
            {
                build: function () {
                    this.constructor.superclass.build.call(this);
                },
                clear: function () {
                    this.constructor.superclass.clear.call(this);
                },
                onSublayoutSizeChange: function () {
                    MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);
                    if(!this._isElement(this._$element)) {
                        return;
                    }
                    this.events.fire('shapechange');
                },
                getShape: function () {
                    if(!this._isElement(this._$element)) {
                        return MyBalloonLayout.superclass.getShape.call(this);
                    }

                    var position = this._$element.position();

                    return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                        [position.left, position.top], [
                            position.left + this._$element[0].offsetWidth,
                            position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
                        ]
                    ]));
                },
                _isElement: function (element) {
                    return element && element[0] && element.find('.arrow')[0];
                }
            }
        );
    map.setMarkerInfo([
        {
            coords: [59.92433655, 30.48690006]
        }
    ]);
    map.setPlacemarkProperties({
        'iconCaption': 'ул. Коллонтай д. 32.к1 кв 38'
    });
    map.setPlacemarkOptions({
        'preset': 'islands#blueCircleDotIconWithCaption',
        'balloonLayout': MyBalloonLayout,
        'balloonPanelMaxMapArea': 0
    });
    map.initMap();
    map.obMap.behaviors.disable('scrollZoom');
});
