export type SupplierRequest = {
  ruc: string;
  business_name: string;
  trade_name?: string;
  address: string;
  economic_activity?: string;
  registration_date?: string;
  email?: string;
  website?: string;
  sales_executive: string;
  contact_person?: string;
  position?: string;
  expected_rate?: number;
  commission?: number;
  notes?: string;
};

export type SupplierResource = {
  id: number;
  ruc: string;
  business_name: string;
  trade_name: string | null;
  address: string;
  economic_activity: string | null;
  activity_start_date: string | null;
  email: string | null;
  website: string | null;
  sales_executive: string;
  contact_person: string | null;
  position: string | null;
  expected_rate: number | null;
  commission: number | null;
  notes: string | null;
  created_at: string;
  updated_at: string;
};

export type SupplierCreateResponse = {
  message: string;
  data: SupplierResource;
};

export type SupplierListResponse = {
  data: SupplierResource[];
  pagination?: {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
  };
};
