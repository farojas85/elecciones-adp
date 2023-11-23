export default class Auth {
    constructor(user){
        this.user = JSON.parse(user)
    }

    roles() {
        return this.user.roles.map(role => role.slug);
    }

    hasRole($role) {
        return this.roles().includes($role);
    }

    permisos() {
        return this.user.permisos.map(permiso=>permiso.slug);
    }

    menus() {
        return this.user.menus;
    }

    can($slugPermiso) {
        return this.permisos().includes($slugPermiso);
    }
}
