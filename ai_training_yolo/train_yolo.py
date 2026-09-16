from ultralytics import YOLO

def main():
    model = YOLO('yolov8n.pt')

    print("Memulai proses training (download otomatis dataset coco8)...")
    results = model.train(
        data='coco8.yaml', 
        epochs=1,          
        imgsz=640
    )
    
    print("Training selesai! File weights tersimpan di: runs/detect/train/weights/best.pt")

if __name__ == '__main__':
    main()