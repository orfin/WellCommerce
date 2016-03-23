var openCategoryEditor = function (sId) {
    if (sId == undefined) {
        window.location = Routing.generate('admin.category.index');
    }
    else {
        window.location = Routing.generate('admin.category.edit', {id: sId});
    }
};

var duplicateCategory = function (sId) {
    window.location = Routing.generate('admin.category.duplicate', {id: sId});
};

var addCategory = function (oRequest) {
    GF_Ajax_Request(Routing.generate('admin.category.add'), oRequest, function (oData) {
        window.location = Routing.generate('admin.category.edit', {id: oData.id});
    });
};

var deleteCategory = function (oRequest) {
    GF_Ajax_Request(Routing.generate('admin.category.delete', {id: oRequest.id}), oRequest, function (oData) {
        window.location = Routing.generate('admin.category.index');
    });
};

var changeOrder = function (oRequest) {
    GF_Ajax_Request(Routing.generate('admin.category.sort'), oRequest);
};