import { usePage } from "@inertiajs/react";

export default function hasAnyPermission(permissions){

    // destruct auth from usepage props
    const { auth } = usePage().props
    
    // get all permissions from props auth
    let allPermissions = auth.permissions;


 return;

   
}