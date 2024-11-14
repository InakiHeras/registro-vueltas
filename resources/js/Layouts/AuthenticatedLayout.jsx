import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import MenuArray from "@/Arrays/MenuArray";
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import PropTypes, { any } from 'prop-types';
import { Link, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import MenuAdmin from '@/Arrays/MenuAdmin';

export default function AuthenticatedLayout({ header, children, admin, accionNav = false, renderAction = any }) {
    const user = usePage().props.auth.user;
    /*const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);
    */
    useEffect(() => {
        /* Aside & Navbar: dropdowns */
        const dropdowns = Array.from(document.getElementsByClassName('dropdown'));
        dropdowns.forEach(elA => {
            elA.addEventListener('click', handleDropdownClick);
        });

        /* Aside Mobile toggle */
        const mobileAsideButtons = Array.from(document.getElementsByClassName('mobile-aside-button'));
        mobileAsideButtons.forEach(el => {
            el.addEventListener('click', handleMobileAsideToggle);
        });

        /* NavBar menu mobile toggle */
        const navbarToggles = Array.from(document.getElementsByClassName('--jb-navbar-menu-toggle'));
        navbarToggles.forEach(el => {
            el.addEventListener('click', handleNavbarToggle);
        });

        /* Modal: open */
        const modalOpeners = Array.from(document.getElementsByClassName('--jb-modal'));
        modalOpeners.forEach(el => {
            el.addEventListener('click', handleModalOpen);
        });

        /* Modal: close */
        const modalClosers = Array.from(document.getElementsByClassName('--jb-modal-close'));
        modalClosers.forEach(el => {
            el.addEventListener('click', handleModalClose);
        });

        /* Notification dismiss */
        const notificationsDismiss = Array.from(document.getElementsByClassName('--jb-notification-dismiss'));
        notificationsDismiss.forEach(el => {
            el.addEventListener('click', handleNotificationDismiss);
        });

        // Cleanup function to remove event listeners
        return () => {
            dropdowns.forEach(elA => {
                elA.removeEventListener('click', handleDropdownClick);
            });
            mobileAsideButtons.forEach(el => {
                el.removeEventListener('click', handleMobileAsideToggle);
            });
            navbarToggles.forEach(el => {
                el.removeEventListener('click', handleNavbarToggle);
            });
            modalOpeners.forEach(el => {
                el.removeEventListener('click', handleModalOpen);
            });
            modalClosers.forEach(el => {
                el.removeEventListener('click', handleModalClose);
            });
            notificationsDismiss.forEach(el => {
                el.removeEventListener('click', handleNotificationDismiss);
            });
        };
    }, []);

    const handleDropdownClick = (e) => {
        if (e.currentTarget.classList.contains('navbar-item')) {
            e.currentTarget.classList.toggle('active');
        } else {
            const dropdownIcon = e.currentTarget.getElementsByClassName('mdi')[1];
            e.currentTarget.parentNode.classList.toggle('active');
            dropdownIcon.classList.toggle('mdi-plus');
            dropdownIcon.classList.toggle('mdi-minus');
        }
    };

    const handleMobileAsideToggle = (e) => {
        const dropdownIcon = e.currentTarget
            .getElementsByClassName('icon')[0]
            .getElementsByClassName('mdi')[0];

        document.documentElement.classList.toggle('aside-mobile-expanded');
        dropdownIcon.classList.toggle('mdi-forwardburger');
        dropdownIcon.classList.toggle('mdi-backburger');
    };

    const handleNavbarToggle = (e) => {
        const dropdownIcon = e.currentTarget
            .getElementsByClassName('icon')[0]
            .getElementsByClassName('mdi')[0];

        document.getElementById(e.currentTarget.getAttribute('data-target')).classList.toggle('active');
        dropdownIcon.classList.toggle('mdi-dots-vertical');
        dropdownIcon.classList.toggle('mdi-close');
    };

    const handleModalOpen = (e) => {
        const modalTarget = e.currentTarget.getAttribute('data-target');
        document.getElementById(modalTarget).classList.add('active');
        document.documentElement.classList.add('clipped');
    };

    const handleModalClose = (e) => {
        e.currentTarget.closest('.modal').classList.remove('active');
        document.documentElement.classList.remove('is-clipped');
    };

    const handleNotificationDismiss = (e) => {
        e.currentTarget.closest('.notification').classList.add('hidden');
    };

    //Comprobamos si tiene el rol de administrador
    const isAdmin = Boolean(admin.roles.find(role => role.name === "admin"));

    return (
        <div className="min-h-screen bg-gray-100 text-base pt-14 lg:pl-60">

            {/* Barra de navegación */}
            <nav id="navbar-main" className="navbar is-fixed-top shadow-md">
                <div className="navbar-brand">
                    <a className="navbar-item mobile-aside-button">
                        <span className="icon"><i className="mdi mdi-forwardburger mdi-24px"></i></span>
                    </a>
                    <div className="navbar-item">
                        <div className="control">
                            {
                                accionNav ? renderAcction : null
                            }
                        </div>
                    </div>
                </div>
                <div className="navbar-brand is-right">
                    <a className="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
                        <span className="icon"><i className="mdi mdi-dots-vertical mdi-24px"></i></span>
                    </a>
                </div>
                <div className="navbar-menu" id="navbar-menu">
                    <div className="navbar-end">
                        <div className="navbar-item dropdown has-divider has-user-avatar">
                            <a className="navbar-link">
                                {/*<div className="user-avatar">
                                    <img src="https://api.dicebear.com/9.x/initials/svg?seed=john-doe" alt="John Doe" className="rounded-full"/>
                                </div>*/}
                                <div className="is-user-name"><span> {user.name} </span></div>
                                <span className="icon"><i className="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div className="navbar-dropdown">
                                {/*<a href="/profile" className="navbar-item">
                                    <span className="icon"><i className="mdi mdi-account"></i></span>
                                    <span>Perfil</span>
                                </a>*/}
                                <a className="navbar-item">
                                    <span className="icon"><i className="mdi mdi-logout"></i></span>
                                    <span>Cerrar sesión</span>
                                </a>
                            </div>
                        </div>
                        <NavLink
                            classInput="navbar-item desktop-icon-only"
                            icon="mdi mdi-logout"
                            href={route('logout')} method="post" as="button"
                        />
                    </div>
                </div>
            </nav>

            {/* Barra lateral */}
            <aside className="aside is-placed-left is-expanded">
                <div className="aside-tools">
                    <div>
                        Admin <b className="font-black">Registro de Vueltas</b>
                    </div>
                </div>
                <div className="menu is-menu-main">
                    {MenuArray.map((item, index) => (

                        item.options.some(option => admin.permissions.includes(option.permiso)) ||  isAdmin ? (
                            <div key={index + 'div_menu'}>
                                <p className="menu-label" key={index + '_label'}> {item.label} </p>
                                <ul className="menu-list" key={index + '_ul_list'}>
                                    {
                                        item.options.map((linke, i) => (
                                            (Boolean(admin.roles.find(role => role.name === "admin")) ||
                                                admin.permissions.includes(linke.permiso)) ?
                                                (
                                                    <li key={i + '_li_item'}>
                                                        <NavLink
                                                            key={i + '_navlink_item'}
                                                            href={route(linke.href)}
                                                            icon={linke.icon}
                                                            name={linke.name}
                                                        />
                                                    </li>
                                                ) : null
                                        ))
                                    }
                                </ul>
                            </div>
                        ) : (null)

                        ))}

                        {/*Admin options*/}
                        {isAdmin ?
                        (
                            <div>
                                <p className="menu-label" key={'1_admin'}>Admin</p>
                                <ul className="menu-list" key={'2_admin'}>
                                    {MenuAdmin.map((adminMenu, i) => (
                                        <li key={'admin_' + adminMenu.name}>
                                            <NavLink
                                                key={'admin_' + adminMenu.name + i}
                                                href={route(adminMenu.href)}
                                                icon={adminMenu.icon}
                                                name={adminMenu.name}
                                            />
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ) : null
                    }
                </div>
            </aside>

            {/* Header */}
            < section className="is-title-bar" >
                <div className="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                    <ul>
                        <li>Autocar</li>
                        <li> {header} </li>
                    </ul>
                </div>
            </section >

            {/* Main Content */}
            <section className="section main-section">{children}</section>
            
        </div>
    );
}
