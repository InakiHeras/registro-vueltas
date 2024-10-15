import ProgressBar from "@/Components/ProgressBar";
import { useEffect, useState } from "react"

export default function EditRole({ role }){
    
    const [loading, setLoading] = useState(true);
    const [permisos, setPermisos] = useState({
        permissions_all: [
            {
                id: '',
                name: '',
                guard_name: '',
                created_at: '',
                updated_at: '',
            }
        ],
        permissions_role: [
            {
                id: '',
                name: '',
                guard_name: '',
                created_at: '',
                updated_at: '',
            }
        ],
    });

    useEffect(() => {
        fetchRolePermissions();
    }, [role.id]);
    
    const fetchRolePermissions = async () => {
        try {
            const response = await axios.get(`/admin/role/${role.id}`);
            setLoading(false);
            setPermisos(response.data);
        } catch (error) {
            console.error("Error fetching role's permissions:", error);
            setLoading(false);
        }
    };

    const updateRolePermissions = async (Accion, PermissionName, RolId) => {
        setLoading(true);
        
        try{
            const reponse = await axios.post(`/admin/role/accion`, {
                Accion: Accion,
                PermissionName: PermissionName,
                RolId: RolId
            });
        } catch (error) {
        } finally {
            setLoading(false);
            fetchRolePermissions();
        }
    }

    console.log(permisos);
    
    return (
        <div className='w-full p-4'>
            <div className="grid grid-cols-2 gap-4">
                <div>
                    <div className='bg-primary p-2 rounded shadow-md text-white'>
                        <h1>Agregar permisos al rol</h1>
                    </div>

                    <div className="mt-2 max-h-96 overflow-scroll h-96 p-2">
                        {
                            loading ? (
                                <div className='flex w-full align-middle justify-center p-6'>
                                    <ProgressBar />
                                </div>
                            ) : (
                                permisos.permissions_all.map((rol, i) => (
                                    <div key={rol + (i + 1)} className='p-2 bg-white rounded hover:shadow-md flex justify-between items-center mt-2'>
                                        <div>
                                            {'Rol: ' + rol.name + ' Tipo: ' + rol.guard_name}
                                        </div>

                                        <button className="button small green" type="button"
                                            onClick={() => updateRolePermissions('ADD', rol.name, role.id)}
                                        >
                                            <span className="icon"><i className="mdi mdi-plus-box"></i></span>
                                        </button>
                                    </div>
                                ))
                            )
                        }
                    </div>
                </div>

                <div>
                <div className='bg-primary p-2 rounded shadow-md text-white'>
                        <h1>Permisos que tiene el rol</h1>
                    </div>
                    <div className="mt-2 max-h-96 overflow-scroll h-96 p-2">
                        {
                            loading ? (
                                <div className='flex w-full align-middle justify-center p-6'>
                                    <ProgressBar />
                                </div>
                            ) : (
                                permisos.permissions_role.map((rol, i) => (
                                    <div key={rol + (i + 1)} className='p-2 bg-white rounded hover:shadow-md flex justify-between items-center mt-2'>
                                        <div>
                                            {rol.name}
                                        </div>

                                        <button className="button small red" type="button"
                                            onClick={() => updateRolePermissions('CLEAN', rol.name, role.id)}
                                        >
                                            <span className="icon"><i className="mdi mdi-delete-alert"></i></span>
                                        </button>
                                    </div>
                                ))
                            )
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}