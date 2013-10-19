//
//  MatchDetailViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 11/01/13.
//  Copyright (c) 2013 Jesse. All rights reserved.
//

#import "MatchDetailViewController.h"
#import <RestKit/RestKit.h>

@interface MatchDetailViewController ()

@property (nonatomic, retain) NSTimer* timer;

@end

@implementation MatchDetailViewController

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    [self loadMatch];
    
    //self.timer = [NSTimer scheduledTimerWithTimeInterval:30.0 target:self selector:@selector(loadMatch) userInfo:nil repeats:YES];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void) loadMatch
{
    
    // Competition mapping
    RKObjectMapping* articleMapping = [RKObjectMapping mappingForClass:[Match class]];
    [articleMapping addAttributeMappingsFromDictionary:@{
     @"id": @"identifier",
     @"start_time": @"startTime",
     @"home_score": @"homeScore",
     @"away_score": @"awayScore",
     }];
    
    // Add relationship
//    [articleMapping addPropertyMapping:[RKRelationshipMapping relationshipMappingFromKeyPath:@"teams" toKeyPath:@"teams" withMapping:teamMapping]];
    
    RKResponseDescriptor *responseDescriptor = [RKResponseDescriptor responseDescriptorWithMapping:articleMapping pathPattern:nil keyPath:@"matches" statusCodes:RKStatusCodeIndexSetForClass(RKStatusCodeClassSuccessful)];
    
    NSString *urlString = [NSString stringWithFormat:@"http://www.matchtracker.be/api/matches/%@", self.identifier];
    NSURL *URL = [NSURL URLWithString:[NSString stringWithFormat:@"%@", urlString]];
    NSURLRequest *request = [NSURLRequest requestWithURL:URL];
    RKObjectRequestOperation *objectRequestOperation = [[RKObjectRequestOperation alloc] initWithRequest:request responseDescriptors:@[ responseDescriptor ]];
    [objectRequestOperation setCompletionBlockWithSuccess:^(RKObjectRequestOperation *operation, RKMappingResult *mappingResult) {        
        // Set data
        self.match = [[mappingResult array] objectAtIndex:0];
        
        self.lblHomeScore.text = [NSString stringWithFormat:@"%@", self.match.homeScore];
        self.lblAwayScore.text = [NSString stringWithFormat:@"%@", self.match.awayScore];
        
        // Reload the table
        [self.tableView reloadData];
        
        // Stop loading
        [self stopLoading];
        
    } failure:^(RKObjectRequestOperation *operation, NSError *error) {
        RKLogError(@"Operation failed with error: %@", error);
    }];
    
    [objectRequestOperation start];
}


// Pull to refresh implementation
- (void)refresh {
    [self performSelector:@selector(loadMatch) withObject:nil afterDelay:0];
}

#pragma mark - Table view data source

//- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
//{
//#warning Potentially incomplete method implementation.
//    // Return the number of sections.
//    return 0;
//}

//- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
//{
//#warning Incomplete method implementation.
//    // Return the number of rows in the section.
//    return 0;
//}
//
//- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
//{
//    static NSString *CellIdentifier = @"Cell";
//    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier forIndexPath:indexPath];
//    
//    // Configure the cell...
//    
//    return cell;
//}

/*
// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}
*/

/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    }   
    else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Navigation logic may go here. Create and push another view controller.
    /*
     <#DetailViewController#> *detailViewController = [[<#DetailViewController#> alloc] initWithNibName:@"<#Nib name#>" bundle:nil];
     // ...
     // Pass the selected object to the new view controller.
     [self.navigationController pushViewController:detailViewController animated:YES];
     */
}

- (void)viewDidUnload {
    [self.timer invalidate];
    self.timer = nil;
    [self setLblHomeScore:nil];
    [self setLblAwayScore:nil];
    [self setTxtEvents:nil];
    [super viewDidUnload];
}
@end
