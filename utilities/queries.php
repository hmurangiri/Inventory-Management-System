Creating the OrdersView

SELECT 
    O.OrderID AS ID, 
    OT.Name AS Ordertype, 
    CT.Name AS Category,
    O.ProductID AS ProductID, 
    P.Name AS Product, 
    O.Quantity AS Quantity, 
    C.Name AS Customer, 
    S.Name AS Supplier, 
    O.BPrice AS Buyingprice, 
    O.SPrice AS Sellingprice, 
    CASE WHEN OT.OrdertypeID = 1 THEN O.Quantity * O.BPrice ELSE NULL END AS TotalPurchases,
    CASE WHEN OT.OrdertypeID = 2 THEN O.Quantity * O.SPrice ELSE NULL END AS TotalSales,
    CASE WHEN OT.OrdertypeID = 2 THEN O.Quantity * (O.SPrice - O.BPrice) ELSE NULL END AS Profit,
    U.Email AS User, 
    O.StoreID AS StoreID, 
    O.Timestamp AS Time
FROM orders O
    INNER JOIN ordertypes OT ON OT.OrdertypeID = O.OrdertypeID
    LEFT JOIN customers C ON C.CustomerID = O.CustomerID
    LEFT JOIN suppliers S ON S.SupplierID = O.SupplierID
    INNER JOIN products P ON P.ProductID = O.ProductID
    INNER JOIN categories CT ON P.CategoryID = CT.CategoryID
    INNER JOIN users U ON U.UserID = O.UserID
    
