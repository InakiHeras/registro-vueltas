import { Link } from '@inertiajs/react';

export default function NavLink({ classInput = '', name = '', icon = '' ,active = false, className = '', children, ...props }) {
    return (
        <Link
            {...props}
            className={classInput}
        >
            <span className="icon"><i className={icon}></i></span>
            <span className="menu-item-label"> {name} </span>
        </Link>
    );
}
