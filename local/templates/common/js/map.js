ymaps.ready(function(){
    let map = new obMap({
            mapId: "map",
            mapCenter: [52.62885564, 39.5280958],
            mapZoom: 17
        }),
        MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="width:270px;height:136px;margin-left:-185px;margin-top:-136px"><img src="/local/templates/common/images/logo-on-map.png"></div>',
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
            coords: [52.62885564, 39.5280958]
        }
    ]);
    map.setPlacemarkProperties({
        'iconCaption': 'Лебедянское шоссе, 1Б'
    });
    map.setPlacemarkOptions({
        'preset': 'islands#blueCircleDotIconWithCaption',
        'balloonLayout': MyBalloonLayout,
        'balloonPanelMaxMapArea': 0
    });
    map.initMap();
    map.obMap.behaviors.disable('scrollZoom');
});
