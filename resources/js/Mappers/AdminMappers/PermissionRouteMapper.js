const PermissionRouteMapper = (responseData) => {
    if (!responseData || !Array.isArray(responseData)) {
        return [
            {
                label: '',
                value: '',
                method:'',
                url:'',
            }
        ]; // Si los datos no son válidos o están vacíos, devuelve un objeto vacío
    }

    return responseData.map(item => ({
        label: item.permiso + ' - ' + item.method + ' - /' + item.url,
        value: item.permiso,
        method:item.method,
        url:item.url,
    }));
}

export default PermissionRouteMapper