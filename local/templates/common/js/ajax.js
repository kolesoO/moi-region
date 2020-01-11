var obAjax = {

    params: {},

    /**
     *
     * @param _params
     */
    setParams: function(_params)
    {
        this.params = (_params ? _params : {});
    },

    /**
     *
     * @param obData
     * @returns {string}
     */
    serializeData: function(obData, prefixKey)
    {
        var return_str = "",
            hasPrefix = !!prefixKey;

        if(Object.keys(obData).length > 0){
            for(var i in obData){
                if (hasPrefix) {
                    i = prefixKey + "[" + i + "]";
                }
                if(typeof obData[i] == "object"){
                    for(var j in obData[i]){
                        if(typeof obData[i][j] == "object"){
                            for(var k in obData[i][j]){
                                if(typeof obData[i][j][k] == "object"){
                                    for(var l in obData[i][j][k]){
                                        if (return_str.length > 0) {
                                            return_str += "&";
                                        }
                                        return_str += i + "[" + j + "][" + k + "][" + l + "]=" + obData[i][j][k][l];
                                    }
                                } else {
                                    if (return_str.length > 0) {
                                        return_str += "&";
                                    }
                                    return_str += i + "[" + j + "][" + k + "]=" + obData[i][j][k];
                                }
                            }
                        } else {
                            if (return_str.length > 0) {
                                return_str += "&";
                            }
                            return_str += i + "[" + j + "]=" + obData[i][j];
                        }
                    }
                } else{
                    if (return_str.length > 0) {
                        return_str += "&";
                    }
                    return_str += i + "=" + obData[i];
                }
            }
        }

        return return_str;
    },

    /**
     *
     * @param form
     */
    getFormObject: function(form)
    {
        var values = {},
            inputs = form.elements;

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].name.length > 0) {
                values[inputs[i].name] = inputs[i].value;
            }
        }

        return values;
    },

    /**
     *
     * @param offerId
     * @param priceId
     * @param evt
     */
    addToBasket: function(offerId, priceId, evt)
    {
        evt.preventDefault();

        var ctx = this,
            $qntTarget = $($(evt.target).attr("data-qnt-target")),
            newParams = {
                offer_id: typeof offerId != "object" ? [offerId] : offerId,
                price_id: priceId
            };
        //fix
        if ($qntTarget.length <= 0) {
            $qntTarget = $($(evt.target).closest("a").attr("data-qnt-target"));
        }
        //end fix
        if ($qntTarget.length > 0) {
            newParams.qnt = $qntTarget.val();
        }
        ctx.setParams(newParams);
        ctx.doRequest(
            "POST",
            location.href,
            ctx.serializeData({
                class: "Basket",
                method: "add",
                params: ctx.params
            }),
            [
                ["Content-type", "application/x-www-form-urlencoded"]
            ]
        );
    },

    /**
     *
     * @param data
     */
    addToBasketCallBack: function(data)
    {
        BX.onCustomEvent('OnBasketChange');
    },

    clearBasket: function()
    {
        var ctx = this;

        ctx.doRequest(
            "POST",
            location.href,
            ctx.serializeData({
                class: "Basket",
                method: "clear"
            }),
            [
                ["Content-type", "application/x-www-form-urlencoded"]
            ]
        );
    },

    /**
     *
     * @param data
     */
    clearBasketCallBack: function(data)
    {
        if (!data.result) {
            alert('Возникла системная ошибка');
            return;
        }
        location.href = BX.Sale.BasketComponent.params['EMPTY_REDIRECT_PATH'];
    },

    /**
     *
     * @param method
     * @param url
     * @param sendData
     * @param arHeaders
     */
    doRequest: function(method, url, sendData, arHeaders)
    {
        var ctx = this,
            ObXhttp = new XMLHttpRequest(),
            arHeaders = this.getHeaders(arHeaders),
            obResponse = null,
            targetBlock = document.getElementById(ctx.params.target_id);

        ObXhttp.open(method, url, true);
        ObXhttp.onloadstart = function() {
            BX.showWait(targetBlock);
        };
        ObXhttp.onloadend = function() {
            BX.closeWait(targetBlock);
        };
        ObXhttp.onload = function() {
            obResponse = JSON.parse(ObXhttp.responseText);
            if(!!obResponse.answer.js_callback && typeof ctx[obResponse.answer.js_callback] == "function") {
                ctx[obResponse.answer.js_callback](obResponse.answer);
            } else if (!!targetBlock) {
                targetBlock.innerHTML = obResponse.answer.html;
            }
        };
        //заголовки
        if (Object.keys(arHeaders).length > 0) {
            for(var headerKey in arHeaders) {
                ObXhttp.setRequestHeader(headerKey, arHeaders[headerKey] + "");
            }
        }
        //end
        ObXhttp.send(sendData);
    },

    /**
     *
     * @param arHeaders
     */
    getHeaders: function(arHeaders)
    {
        var obReturn = {};
        if (arHeaders.length > 0) {
            for (var counter in arHeaders) {
                if (arHeaders[counter].length == 2) {
                    obReturn[arHeaders[counter][0]] = arHeaders[counter][1];
                }
            }
        }

        return Object.assign(obReturn, this.getDefaultHeaders());
    },

    /**
     *
     * @returns {{"X-Requested-With": string}}
     */
    getDefaultHeaders: function()
    {
        return {
            "X-Requested-With": "xmlhttprequest"
        };
    }
}
