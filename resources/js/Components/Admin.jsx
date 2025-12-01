import React, { useState, useEffect } from "react";
import axios from "axios";
import Sidebar from "./Admin/Sidebar";
import DashboardPage from "./Admin/Dashboard";
import CustomersPage from "./Admin/Customers";
import ServicesPage from "./Admin/Services";
import FinancePage from "./Admin/Finance";

const Admin = () => {
    const [isGlass, setIsGlass] = useState(false);
    const [activeTab, setActiveTab] = useState("dashboard");
    const [orders, setOrders] = useState([]);
    const [services, setServices] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const res = await axios.get("/api/admin/data");

                setOrders(res.data.orders || []);
                setServices(res.data.services || []);
            } catch (error) {
                console.error("Gagal load data admin:", error);
                if (error.response && error.response.status === 401) {
                    window.location.href = "/login";
                }
            } finally {
                setLoading(false);
            }
        };
        fetchData();
    }, []);

    const updateStatus = async (id, newStatus) => {
        setOrders(
            orders.map((o) => (o.id === id ? { ...o, status: newStatus } : o))
        );
        await axios.post(`/api/admin/order/${id}/status`, {
            status: newStatus,
        });
    };

    const updatePrice = async (id, newPrice) => {
        setServices(
            services.map((s) => (s.id === id ? { ...s, price: newPrice } : s))
        );
        await axios.post(`/api/admin/service/${id}/update`, {
            price: newPrice,
        });
    };

    const addService = async (newService) => {
        try {
            const res = await axios.post("/api/admin/service/add", newService);

            setServices([...services, res.data.data]);

            alert("Layanan berhasil ditambahkan!");
        } catch (e) {
            console.error(e);
            alert("Gagal tambah layanan. Cek console.");
        }
    };

    const deleteService = async (id) => {
        if (window.confirm("Yakin ingin menghapus layanan ini?")) {
            try {
                await axios.delete(`/api/admin/service/${id}`);

                setServices(services.filter((s) => s.id !== id));
            } catch (e) {
                console.error(e);
                alert("Gagal hapus layanan.");
            }
        }
    };

    const style = {
        bg: isGlass ? "bg-slate-900 text-white" : "bg-[#f8fafc] text-slate-800",
        card: isGlass
            ? "bg-white/10 backdrop-blur-xl border border-white/20 shadow-md text-white"
            : "bg-white shadow-sm border border-slate-100 text-slate-800",
        input: isGlass
            ? "bg-white/5 border-white/20 text-white placeholder-white/30 focus:ring-cyan-400"
            : "bg-slate-50 border-slate-200 text-slate-800 focus:ring-blue-500",
        sidebar: isGlass
            ? "bg-slate-900/80 backdrop-blur-md border-r border-white/10"
            : "bg-[#1e3a8a] text-white shadow-xl",
        activeMenu: isGlass
            ? "bg-cyan-500/20 text-cyan-300 border-r-4 border-cyan-400"
            : "bg-white/10 text-white font-bold border-r-4 border-white",
        textMuted: isGlass ? "text-blue-200" : "text-slate-500",
        btnPrimary: isGlass
            ? "bg-gradient-to-r from-cyan-500 to-blue-500 hover:shadow-cyan-500/50 text-white"
            : "bg-[#1e3a8a] hover:bg-blue-800 text-white shadow-lg",
    };

    const renderContent = () => {
        if (loading)
            return (
                <div className="flex h-full items-center justify-center">
                    Memuat Data...
                </div>
            );

        switch (activeTab) {
            case "dashboard":
                return (
                    <DashboardPage
                        style={style}
                        orders={orders}
                        isGlass={isGlass}
                    />
                );
            case "pelanggan":
                return (
                    <CustomersPage
                        style={style}
                        isGlass={isGlass}
                        orders={orders}
                        updateStatus={updateStatus}
                    />
                );
            case "layanan":
                return (
                    <ServicesPage
                        style={style}
                        isGlass={isGlass}
                        services={services}
                        updatePrice={updatePrice}
                        addService={addService}
                        deleteService={deleteService}
                    />
                );
            case "keuangan":
                return (
                    <FinancePage
                        style={style}
                        orders={orders}
                        isGlass={isGlass}
                    />
                );
            default:
                return <div>Halaman tidak ditemukan</div>;
        }
    };

    return (
        <div
            className={`min-h-screen flex font-sans transition-colors duration-500 ${style.bg}`}
        >
            {isGlass && <div className="fixed inset-0 bg-slate-900 z-0"></div>}

            <Sidebar
                activeMenu={activeTab}
                setActiveMenu={setActiveTab}
                isGlass={isGlass}
                setIsGlass={setIsGlass}
                style={style}
            />

            <div className="flex-1 ml-20 md:ml-64 p-8 relative z-10">
                {renderContent()}
            </div>
        </div>
    );
};

export default Admin;
