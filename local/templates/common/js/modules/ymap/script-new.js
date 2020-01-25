/**
 *
 */
function obMap(params){

    this.obParams = params.general || {};
    this.obMap = null;
    this.arMarkerInfo = [];
    this.obPlacemarkProperties = [];
    this.obPlacemarkOptions = [];

    if (!!params.marker_info) {
        for (var key in params.marker_info) {
            this.setMarkerInfo(params.marker_info[key]);
        }
    }
    if (!!params.marker_props) {
        for (var key in params.marker_props) {
            this.setPlacemarkProperties(params.marker_props[key]);
        }
    }
    if (!!params.marker_options) {
        for (var key in params.marker_options) {
            if (key == 'balloonLayout') {
                params.marker_options[key] = this.getBaloon(params.marker_options[key]);
            }
            this.setPlacemarkOptions(params.marker_options[key]);
        }
    }
    console.log(this);

}

/**
 *
 * @param strMsg
 */
obMap.prototype.showMessage = function(strMsg){

    console.log(strMsg);

};

/**
 *
 * @param arCoords
 * @param props
 * @param options
 * @returns {ymaps.Placemark}
 */
obMap.prototype.getGeoPlaceMark = function(arCoords, props, options){

    return new ymaps.Placemark(arCoords, props, options);

};

/**
 *
 * @param obProps
 */
obMap.prototype.setPlacemarkProperties = function(obProps){

    this.obPlacemarkProperties.push(obProps);

};

/**
 *
 * @param obProps
 */
obMap.prototype.setPlacemarkOptions = function(obProps){

    this.obPlacemarkOptions.push(obProps);

};

/**
 *
 * @param info
 */
obMap.prototype.setMarkerInfo = function(info){

    this.arMarkerInfo.push(info);

};

/**
 *
 * @param arCoords
 * @param arCoordsInner
 * @param obProps
 * @param obOptions
 * @returns {ymaps.Polygon}
 */
obMap.prototype.getPolygon = function(arCoords, arCoordsInner, obProps, obOptions){

    return new ymaps.Polygon([arCoords, arCoordsInner], obProps, obOptions);

};

/**
 *
 * @param arCoords
 * @param arCoordsInner
 * @param obProps
 * @param obOptions
 */
obMap.prototype.setPolygon = function(arCoords, arCoordsInner, obProps, obOptions){

    if(!!this.obMap){
        this.obMap.geoObjects.add(this.getPolygon(arCoords, arCoordsInner, obProps, obOptions));
    }

};

obMap.prototype.getBaloon = function(params)
{
    var content = '',
        MyBalloonLayout;

    if (!!params.image) {
        content += '<div style="width:270px;height:136px;margin-left:-185px;margin-top:-136px" class="card-body bg-white"><img src="/local/templates/common/images/logo.png"></div>';
    }
    if (!!params.text) {
        content += '<div>' + params.text + '</div>'
    }

    MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
        content,
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

    return MyBalloonLayout;
};

/**
 *
 */
obMap.prototype.initMap = function(){

    var ctx = this;

    if(ctx.arMarkerInfo.length > 0){
        if(!ctx.obMap){
            ctx.obMap = new ymaps.Map(ctx.obParams.map_id,{
                center: ctx.obParams.map_center || [],
                zoom: ctx.obParams.map_zoom || ''
            });
        }
        ctx.arMarkerInfo.forEach(function(obMarkerInfo, index){
            ctx.obMap.geoObjects.add(
                ctx.getGeoPlaceMark(
                    obMarkerInfo.coords[index],
                    ctx.obPlacemarkProperties[index],
                    ctx.obPlacemarkOptions[index]
                )
            );
        });
    }

};
