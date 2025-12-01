import React from "react";
import { motion } from "framer-motion";
import SectionWrapper from "./SectionWrapper";

const Tracking = ({ isGlass, order }) => {
    if (!order) return null;

    const statuses = ["Menunggu", "Dicuci", "Disetrika", "Selesai"];
    const currentStep = statuses.indexOf(order.status);

    const containerClass = isGlass
        ? "bg-white/10 backdrop-blur-xl border border-white/20 text-white"
        : "bg-white shadow-soft border border-blue-50 text-slate-800";
    const textMuted = isGlass ? "text-blue-200" : "text-slate-500";

    return (
        <SectionWrapper
            id="tracking"
            className="bg-secondary"
            isGlass={isGlass}
        >
            <div className="text-center mb-10 relative z-10">
                <h2
                    className={`text-3xl font-bold ${
                        isGlass ? "text-white" : "text-slate-800"
                    }`}
                >
                    Tracking Pesanan
                </h2>
            </div>

            <div
                className={`${containerClass} rounded-[40px] w-full max-w-4xl overflow-hidden p-8`}
            >
                <div className="flex justify-between items-center mb-8 border-b pb-4 border-gray-100/20">
                    <div>
                        <h3 className="font-bold text-xl">Order #{order.id}</h3>
                        <p className={`text-sm ${textMuted}`}>
                            {order.service} • {order.weight}kg
                        </p>
                    </div>
                    <div className="text-right">
                        <p
                            className={`font-bold text-xl ${
                                isGlass ? "text-cyan-300" : "text-blue-600"
                            }`}
                        >
                            Rp {order.total.toLocaleString()}
                        </p>
                        <span className="bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2 py-1 rounded">
                            {order.status}
                        </span>
                    </div>
                </div>

                <div className="relative flex justify-between items-center">
                    <div className="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10 rounded-full"></div>

                    <motion.div
                        initial={{ width: 0 }}
                        animate={{
                            width: `${
                                (currentStep / (statuses.length - 1)) * 100
                            }%`,
                        }}
                        className="absolute top-1/2 left-0 h-1 bg-green-500 -z-10 rounded-full"
                        transition={{ duration: 1 }}
                    />

                    {statuses.map((status, index) => {
                        const isDone = index <= currentStep;
                        return (
                            <div
                                key={index}
                                className="flex flex-col items-center bg-transparent"
                            >
                                <div
                                    className={`w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-4 transition-colors duration-500
                                    ${
                                        isDone
                                            ? "bg-green-500 border-green-200 text-white"
                                            : "bg-white border-gray-200 text-gray-400"
                                    }`}
                                >
                                    {index + 1}
                                </div>
                                <p
                                    className={`text-xs mt-2 font-bold ${
                                        isDone
                                            ? isGlass
                                                ? "text-white"
                                                : "text-slate-800"
                                            : "text-slate-400"
                                    }`}
                                >
                                    {status}
                                </p>
                            </div>
                        );
                    })}
                </div>
            </div>
        </SectionWrapper>
    );
};

export default Tracking;
