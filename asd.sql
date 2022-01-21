SELECT b.id AS board_id, b.user_id, b.name, x.pin_id, y.total, c.title, c.description, c.type, c.media FROM 
        (SELECT board_id, pin_id, rn FROM 
            (SELECT bd.board_id, bd.pin_id, ROW_NUMBER() OVER (PARTITION BY bd.board_id ORDER BY bd.timestamp DESC) AS rn 
            FROM board_details bd) AS tmp 
        WHERE tmp.rn <= 3) AS x 
            RIGHT JOIN 
        (SELECT b.id AS board_id, IFNULL(count(bd.pin_id), 0) AS 'total' 
        FROM board_details bd 
        RIGHT JOIN boards b on bd.board_id = b.id
        GROUP BY bd.board_id) y ON x.board_id = y.board_id 
        LEFT JOIN pins c ON c.id = x.pin_id 
        RIGHT JOIN boards b ON b.id = x.board_id 
        WHERE b.user_id = '9e7d27cf-71d9-11ec-9b11-0c9d9205636c'

SELECT b.id AS board_id, b.user_id, b.name, x.pin_id, IFNULL(y.total, 0) AS total, c.title, c.description, c.type, c.media, x.timestamp FROM 
        (SELECT board_id, pin_id, timestamp, rn FROM 
            (SELECT bd.board_id, bd.pin_id, bd.timestamp, ROW_NUMBER() OVER (PARTITION BY bd.board_id ORDER BY bd.timestamp DESC) AS rn 
            FROM board_details bd) AS tmp 
        WHERE tmp.rn <= 3) AS x 
            RIGHT JOIN 
        (SELECT b.id AS board_id, bd.timestamp, IFNULL(count(bd.pin_id), 0) AS 'total' 
        FROM board_details bd 
        RIGHT JOIN boards b on bd.board_id = b.id
        GROUP BY bd.board_id) y ON x.board_id = y.board_id 
        LEFT JOIN pins c ON c.id = x.pin_id 
        RIGHT JOIN boards b ON b.id = x.board_id 
        WHERE b.user_id = '9e7d27cf-71d9-11ec-9b11-0c9d9205636c'

SELECT * FROM 
        (SELECT board_id, pin_id, rn FROM 
            (SELECT bd.board_id, bd.pin_id, bd.timestamp, ROW_NUMBER() OVER (PARTITION BY bd.board_id ORDER BY bd.timestamp DESC) AS rn 
            FROM board_details bd) AS tmp 
        WHERE tmp.rn <= 3) AS x 
            RIGHT JOIN 
        (SELECT b.id AS board_id, bd.timestamp, IFNULL(count(bd.pin_id), 0) AS 'total' 
        FROM board_details bd 
        RIGHT JOIN boards b on bd.board_id = b.id
        GROUP BY bd.board_id) y ON x.board_id = y.board_id 
        LEFT JOIN pins c ON c.id = x.pin_id 
        RIGHT JOIN boards b ON b.id = x.board_id 
        WHERE b.user_id = '9e7d27cf-71d9-11ec-9b11-0c9d9205636c'