import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function SelectInput({ label,options = [], className = '', isFocused = false, ...props }, ref) {
    const selectRef = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            selectRef.current.focus();
        }
    }, []);

    return (
        <select
            {...props}
            className={
                'border-none focus:border-primary focus:ring-primary rounded-md shadow-md ' +
                className
            }
            ref={selectRef}
        >
            <option value="">{label}</option>
            {options.map((option, index) => (
                <option key={index} value={option.value} className='bg-white text-gray-900'>
                    {option.label}
                </option>
            ))}
        </select>
    );
});
