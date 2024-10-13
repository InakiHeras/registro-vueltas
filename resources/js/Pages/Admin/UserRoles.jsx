import ProgressBar from "@/Components/ProgressBar";
import axios from "axios";
import { useState, useEffect } from "react";

export default function UserRoles({ user }) {
    
    const [loading, setLoading,] = useState(true);
    const [rolesAll, setRolesAll] = useState([]);
    const [userRoles, setUserRoles] = useState([]);

    useEffect(() => {
        fetchRoles();
    }, [user.id]);

    const fetchRoles = async () => {
        try {
            const response = await axios.get(`/admin/users/${user.id}/roles`);
            setRolesAll(response.data.rolesAll);
            setUserRoles(response.data.userRoles);
            setLoading(false);
        } catch (error) {
            console.error("Error fetching roles:", error);
        }
    };

    const UpdateRolesUser = async (action, roleName, userId) => {
        try {
            const response = await axios.post(`/admin/users/${userId}/roles`, {
                action: action,
                role: roleName,
            });
            // Actualizar las listas de roles después de la actualización en el servidor
            setRolesAll(response.data.rolesAll);
            setUserRoles(response.data.userRoles);
        } catch (error) {
            console.error("Error updating roles:", error);
        }
    };

    return (
        <div className="w-full p-4">
            <div className="grid grid-cols-2 gap-4">
                <div>
                    <div className="bg-primary p-2 rounded shadow-md text-white">
                        <h1>Agregar rol al usuario</h1>
                    </div>

                    <div className="mt-2 max-h-96 overflow-scroll h-96 p-2">
                        
                        {
                            loading ? (
                                <div className='flex w-full align-middle justify-center p-6'>
                                    <ProgressBar />
                                </div>
                            ) : (
                                rolesAll.map((rol, i) => (
                                    <div key={rol + (i + 1)} className='p-2 bg-white rounded hover:shadow-md flex justify-between items-center mt-2'>
                                        <div>
                                            {rol.name}
                                        </div>

                                        <button className="button small green" type="button"
                                            onClick={() => UpdateRolesUser('ADD', rol.name, user.id)}//
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
                    <div className="bg-primary p-2 rounded shadow-md text-white">
                        <h1>Roles que tiene el usuario</h1>
                    </div>

                    <div className="mt-2 max-h-96 overflow-scroll h-96 p-2">
                        
                        {
                            loading ? (
                                <div className='flex w-full align-middle justify-center p-6'>
                                    <ProgressBar />
                                </div>
                            ) : (
                                userRoles.map((rol, i) => (
                                    <div key={rol + (i + 1)} className='p-2 bg-white rounded hover:shadow-md flex justify-between items-center mt-2'>
                                        <div>
                                            {rol.name}
                                        </div>

                                        <button className="button small red" type="button"
                                            onClick={() => UpdateRolesUser('CLEAN', rol.name, user.id)}
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