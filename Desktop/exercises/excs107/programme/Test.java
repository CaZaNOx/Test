
public class cs107 {
	
	public static void main(String[] args) {
		String name = "cs107";
		if (args.length > 0) {
			name = args[0];
		}
		System.out.printf("Hello %s\n", name);
	}
}
