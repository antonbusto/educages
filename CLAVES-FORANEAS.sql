ALTER TABLE curso1_foro_temas ADD FOREIGN KEY(categoria_tema) REFERENCES curso1_foro_categorias(id_categoria) ON DELETE CASCADE ON UPDATE CASCADE;  
ALTER TABLE curso1_foro_mensaxes ADD FOREIGN KEY(tema_mensaxe) REFERENCES curso1_foro_temas(id_tema) ON DELETE CASCADE ON UPDATE CASCADE;   
