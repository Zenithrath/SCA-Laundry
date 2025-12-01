import React from "react";
import { motion } from "framer-motion";
import SectionWrapper from "./SectionWrapper";

const Dashboard = ({ isGlass, user }) => {
    if (!user) return null;

    const textTitle = isGlass ? "text-white" : "text-slate-800";
    const textMuted = isGlass ? "text-blue-200" : "text-slate-500";
    const cardClass = isGlass
        ? "bg-white/10 backdrop-blur-xl border border-white/20 text-white"
        : "bg-white shadow-soft text-slate-800";

    return (
        <SectionWrapper
            id="dashboard"
            className={isGlass ? "" : "bg-cardblue/30"}
            isGlass={isGlass}
        >
            <div className="text-center mb-8 relative z-10">
                <h2 className={`text-3xl font-bold ${textTitle}`}>
                    Dashboard Pelanggan
                </h2>
            </div>

            <div className="w-full max-w-4xl space-y-6 relative z-10">
                <div
                    className={`${cardClass} rounded-[40px] p-8 flex flex-col md:flex-row items-center gap-6`}
                >
                    <div className="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                        {user.name.charAt(0)}
                    </div>
                    <div className="flex-1 text-center md:text-left">
                        <h3 className={`text-xl font-bold ${textTitle}`}>
                            {user.name}
                        </h3>
                        <p className={`text-xs ${textMuted}`}>{user.email}</p>
                        <p className={`text-xs ${textMuted}`}>
                            {user.phone || "-"}
                        </p>
                    </div>
                    <div className="flex gap-8 text-center">
                        <div>
                            <p className="font-bold text-lg text-blue-500">
                                {user.total_order}
                            </p>
                            <p className="text-[10px]">Total Order</p>
                        </div>
                        <div>
                            <p className="font-bold text-lg text-green-500">
                                Rp {user.total_expense.toLocaleString()}
                            </p>
                            <p className="text-[10px]">Pengeluaran</p>
                        </div>
                        <div>
                            <p className="font-bold text-lg text-yellow-500">
                                {user.points}
                            </p>
                            <p className="text-[10px]">Poin</p>
                        </div>
                    </div>
                </div>
            </div>
        </SectionWrapper>
    );
};

export default Dashboard;
