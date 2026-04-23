import React, { useEffect } from "react";

export default function Toast({ message, type = "success", onClose }) {
    if (!message) return null;

    useEffect(() => {
        if (onClose) {
            const timer = setTimeout(() => onClose(), 3000);
            return () => clearTimeout(timer);
        }
    }, [message, onClose]);

    const config = {
        success: {
            border: "border-teal-500",
            bgIcon: "bg-teal-100",
            textIcon: "text-teal-600",
            icon: "fa-check",
            title: "Operación exitosa",
        },
        error: {
            border: "border-red-500",
            bgIcon: "bg-red-100",
            textIcon: "text-red-600",
            icon: "fa-triangle-exclamation",
            title: "Error",
        },
        info: {
            border: "border-slate-800",
            bgIcon: "bg-slate-100",
            textIcon: "text-slate-800",
            icon: "fa-circle-info",
            title: "Información",
        },
    };

    const current = config[type] || config.info;

    return (
        <div className="fixed bottom-10 right-10 z-[500] animate-slide-up">
            <div className={`bg-white border-l-4 ${current.border} shadow-2xl rounded-xl p-4 flex items-center gap-4 min-w-[300px]`}>
                <div className={`${current.bgIcon} p-2 rounded-full ${current.textIcon}`}>
                    <i className={`fa-solid ${current.icon} text-xl`}></i>
                </div>
                <div className="flex-1">
                    <h4 className="text-slate-800 font-bold text-sm">{current.title}</h4>
                    <p className="text-slate-500 text-xs mt-0.5">{message}</p>
                </div>
                <button onClick={onClose} className="text-slate-400 hover:text-slate-600 transition-colors ml-2">
                    <i className="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    );
}
